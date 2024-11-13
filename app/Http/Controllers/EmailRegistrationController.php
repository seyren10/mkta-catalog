<?php

namespace App\Http\Controllers;

use App\DTO\EmailRegistrationDTO;
use App\Http\Requests\EmailRegistrationStoreRequest;
use App\Models\EmailRegistration;
use App\Services\EmailRegistrationService;
use Illuminate\Http\Request;

class EmailRegistrationController extends Controller
{
    public function __construct(protected EmailRegistrationService $service) {}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EmailRegistrationStoreRequest $request)
    {
        $validated = $request->validated();

        $created = $this->service->create(new EmailRegistrationDTO(
            $validated['email'],
            $validated['company'],
            $validated['region'],
            $validated['comment'] ?? null
        ));

        return response()->json([
            'data' => $created
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(EmailRegistration $emailRegistration)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EmailRegistration $emailRegistration)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EmailRegistration $emailRegistration)
    {
        //
    }
}
