<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Contracts\Services\PhoneBook\PhoneBookService;
use App\Models\Contact;
use App\Models\Phone;
use App\Http\Resources\ContactResource;
use App\Http\Resources\PhoneResource;
use App\Http\Requests\CreatePhoneRequest;
use App\Http\Requests\UpdatePhoneRequest;
use Illuminate\Http\JsonResponse;

class ContactPhoneController extends Controller
{
    /**
     * The PhoneBookService instance.
     *
     * @var PhoneBookService
     */
    private PhoneBookService $phoneBookService;

    /**
     * Create a new controller instance.
     *
     * @param  PhoneBookService  $phoneBookService
     *
     * @return void
     */
    public function __construct(PhoneBookService $phoneBookService)
    {
        $this->phoneBookService = $phoneBookService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  Contact  $contact
     *
     * @return JsonResponse
     */
    public function index(Contact $contact): JsonResponse
    {
        $contact = $this->phoneBookService->loadPhones($contact);

        return ContactResource::make($contact)->response();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreatePhoneRequest  $request
     * @param  Contact  $contact
     *
     * @return JsonResponse
     */
    public function store(CreatePhoneRequest $request, Contact $contact): JsonResponse
    {
        $phone = $this->phoneBookService->addPhone($contact, $request->dataTransferObject());

        return PhoneResource::make($phone)
            ->additional(['message' => 'Created.'])
            ->response();
    }

    /**
     * Display the specified resource.
     *
     * @param  Contact  $contact
     * @param  Phone  $phone
     *
     * @return JsonResponse
     */
    public function show(Contact $contact, Phone $phone): JsonResponse
    {
        return PhoneResource::make($phone)->response();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdatePhoneRequest  $request
     * @param  Contact  $contact
     * @param  Phone  $phone
     *
     * @return JsonResponse
     */
    public function update(UpdatePhoneRequest $request, Contact $contact, Phone $phone): JsonResponse
    {
        $phone = $this->phoneBookService->updatePhone($phone, $request->dataTransferObject());

        return PhoneResource::make($phone)
            ->additional(['message' => 'Updated.'])
            ->response();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Contact  $contact
     * @param  Phone  $phone
     *
     * @return JsonResponse
     */
    public function destroy(Contact $contact, Phone $phone): JsonResponse
    {
        $this->phoneBookService->deletePhone($phone);

        return \response()->json(['message' => 'Deleted.']);
    }
}
