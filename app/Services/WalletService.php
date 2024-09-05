<?php

namespace App\Services;
use App\Repositories\Contracts\WalletRepositoryInterface;

class WalletService
{
    protected $walletRepository;

    public function __construct(WalletRepositoryInterface $walletRepository)
    {
        $this->walletRepository = $walletRepository;
    }

    /**
     * Select all wallets
     * @return array
    */
    public function getAllWallets()
    {
        return $this->walletRepository->getAllWallets();
    }

     /**
     * Create a new wallet
     * @param array $data
     * @return object 
    */
    public function makeWallet(array $data)
    {
        $wallet = $this->walletRepository->createWallet($data);

        return $wallet;
    }

    /**
     * Get Wallet by  ID
     * @param int $id
     * @return object
    */
    public function getWalletById(int $id)
    {
        return $this->walletRepository->getWalletById($id);
    }

    /**
     * Update a wallet
     * @param int $id
     * @param arrray $data
     * @return json response
    */
    public function updateWallet(int $id, array $data)
    {
        $wallet = $this->walletRepository->getWalletById($id);

        if (!$wallet) {
            return response()->json(['message' => 'Wallet Not Found'], 404);
        }

        $this->walletRepository->updateWallet($wallet, $data);
        return response()->json(['message' => 'Wallet Updated'], 200);
    }

    /**
     * Delete a wallet
     * @param int $id
     * @return json response
    */
    public function destroyWallet(int $id)
    {
        $wallet = $this->walletRepository->getWalletById($id);

        if (!$wallet) {
            return response()->json(['message' => 'Wallet Not Found'], 404);
        }

        $this->walletRepository->destroyWallet($wallet);

        return response()->json(['message' => 'Wallet Deleted'], 200);
    }
}