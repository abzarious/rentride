<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Vehicle;
use App\Enums\VehicleStatus;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

class BookingService
{
    protected PriceService $priceService;

    public function __construct(PriceService $priceService)
    {
        $this->priceService = $priceService;
    }

    /**
     * Membuat booking baru beserta validasi & update status kendaraan
     */
    public function createBooking(array $data, int $userId): Booking
    {
        return DB::transaction(function () use ($data, $userId) {
            $vehicle = Vehicle::findOrFail($data['vehicle_id']);

            // Cek ketersediaan status kendaraan
            $statusValue = $vehicle->status instanceof VehicleStatus 
                ? $vehicle->status->value 
                : $vehicle->status;

            if ($statusValue !== 'available') {
                throw new InvalidArgumentException('Kendaraan sedang tidak tersedia untuk disewa.');
            }

            // Hitung durasi dan harga
            $durationDays = $this->priceService->calculateDurationDays($data['start_date'], $data['end_date']);
            $priceDetails = $this->priceService->calculatePriceDetails($vehicle->price_per_day, $durationDays);

            // Generate Invoice Number
            $invoiceNumber = InvoiceService::generate();

            // Simpan Data Booking
            return Booking::create([
                'invoice_number' => $invoiceNumber,
                'user_id'        => $userId,
                'vehicle_id'     => $vehicle->id,
                'start_date'     => $data['start_date'],
                'end_date'       => $data['end_date'],
                'duration_days'  => $priceDetails['duration_days'],
                'price_per_day'  => $priceDetails['price_per_day'],
                'subtotal'       => $priceDetails['subtotal'],
                'admin_fee'      => $priceDetails['admin_fee'],
                'discount'       => $priceDetails['discount'],
                'total_price'    => $priceDetails['total_price'],
                'status'         => 'pending',
                'notes'          => $data['notes'] ?? null,
            ]);
        });
    }

    /**
     * Mengubah status booking dan menyinkronkan status kendaraan
     */
    public function updateBookingStatus(Booking $booking, string $newStatus): bool
    {
        return DB::transaction(function () use ($booking, $newStatus) {
            if (in_array($booking->status, ['completed', 'rejected', 'cancelled'])) {
                throw new InvalidArgumentException('Transaksi ini sudah final dan tidak dapat diubah.');
            }

            $booking->update(['status' => $newStatus]);

            if ($booking->vehicle) {
                if ($newStatus === 'approved') {
                    $booking->vehicle->update(['status' => VehicleStatus::BOOKED->value]);
                } elseif ($newStatus === 'ongoing') {
                    $booking->vehicle->update(['status' => VehicleStatus::RENTED->value]);
                } elseif (in_array($newStatus, ['completed', 'rejected', 'cancelled'])) {
                    $booking->vehicle->update(['status' => VehicleStatus::AVAILABLE->value]);
                }
            }

            return true;
        });
    }
}