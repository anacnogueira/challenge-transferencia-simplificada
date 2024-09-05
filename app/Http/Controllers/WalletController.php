<?php

namespace App\Http\Controllers;

use App\Services\WalletService;
use App\Http\Resources\WalletResource;
use App\Http\Requests\StoreWalletRequest;
use App\Http\Requests\UpdateWalletRequest;
use App\Http\Requests\AddWalletRequest;

class WalletController extends Controller
{
    protected $walletService;

    public function __construct(WalletService $walletService)
    {
        $this->walletService = $walletService;
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $wallets = $this->walletService->getAllWallets();

        return WalletResource::collection($wallets);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreWalletRequest $request)
    {
        $data = $request->all();
        
        $wallet = $this->walletService->makeWallet($data);
        return new WalletResource($wallet);
    }

    /**
     * Add value to resource in storage.
     */
    public function add(AddWalletRequest $request,  string $id)
    {
        $data = $request->all();

        $wallet = $this->walletService->addValueToWallet($data, $id);

        return $wallet;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $wallet = $this->walletService->getWalletById($id);

        return new WalletResource($wallet);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateWalletRequest $request)
    {
        $data = $request->all();
 
        $wallet = $this->walletService->updateWallet($data);

        return $wallet;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $wallet = $this->walletService->destroyWallet($id);

        return $wallet;
    }
}
