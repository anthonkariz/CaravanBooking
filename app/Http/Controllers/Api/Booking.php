<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Util\HttpResponse;
use Illuminate\Http\Request;
use App\Models\Booking as BookingModel;
use Illuminate\Http\JsonResponse;

class Booking extends Controller
{
    //
    use HttpResponse;
    public function index(): JsonResponse
    {
        try {
            $bookings =  BookingModel::all();
            return $this->successResponse('All bookings', $bookings, 200);
        } catch(\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }

    }

    public function show($id)
    {
        try {
            $sigleBooking =  BookingModel::find($id);
            return $this->successResponse('Booking by id', $sigleBooking, 200);
        } catch(\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    public function bookingByCaravan($id): JsonResponse
    {
        try {
            $bookings =  BookingModel::where('caravan_id', $id)->get();
            return $this->successResponse('Booking by caravan', $bookings, 200);
        } catch(\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }


    }
    public function bookingByUser(int $id): JsonResponse
    {
        try {
            $userAndBooking =  BookingModel::where('user_id', $id)->get();
            return $this->successResponse('Booking by user', $userAndBooking, 200);
        } catch(\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }
    public function store(Request $request): JsonResponse
    {
        try {
            $validatedData = $request->validate([
                'start_date' => 'required',
                'end_date' => 'required',
                'caravan_id' => 'required',

            ]);
            BookingModel::create($request->all());
            return $this->successResponse('Booking added successfully', $request->all(), 200);
        } catch(\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    public function update(Request $request, int $id): JsonResponse
    {
        try {
            $booking = BookingModel::find($id)->update($request->all());
            return $this->successResponse('Booking updated successfully', $booking, 200);
        } catch(\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }

    }

    public function destroy(int $id): JsonResponse
    {
        try {
            $delete =  BookingModel::destroy($id);
            return $this->successResponse('Booking deleted successfully', $delete, 200);
        } catch(\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }

    }

    public function bookingByStatus($status): JsonResponse
    {
        try {
            $bookingStatus =  BookingModel::where('status', $status)->get();
            return $this->successResponse('Available to booking', $bookingStatus, 200);
        } catch(\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    public function bookingByPaymentStatus($status): JsonResponse
    {
        try {
            $paymentStatus =  BookingModel::where('payment_status', $status)->get();
            return $this->successResponse('successfully', $paymentStatus, 200);
        } catch(\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }

    }

    public function bookingByPaymentMethod($method)
    {
        try {
            $paymantsMethods =  BookingModel::where('payment_method', $method)->get();
            return $this->successResponse('Available to booking', $paymantsMethods, 200);
        } catch(\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }


    }

    public function bookingByDate(Request $request)
    {

        try {
            $available = BookingModel::filter($request)->get();

            if(count($available) > 0) {
                $available = BookingModel::alternative($request)->get();
                return $this->successResponse('Available to booking', $available, 200);
            }
            return $this->successResponse('Available to booking', $available, 200);

        } catch(\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }


    }





}
