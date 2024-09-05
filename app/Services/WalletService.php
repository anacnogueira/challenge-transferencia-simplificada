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
     * Add value to wallet
     * @param array $data
     * @return object 
    */
    public function addValueToWallet(array $data, $id)
    {
        $wallet = $this->walletRepository->getWalletById($id);   

        if (!$wallet) {
            return response()->json(['message' => 'Wallet Not Found'], 404);
        }

        $wallet->amount = $wallet->amount + (float)$data["amount"];

        $this->walletRepository->updateWallet($wallet);
        return response()->json(['message' => 'Wallet Updated'], 200);
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
     * Get Wallet by  ID
     * @param int $id
     * @return object
    */
    public function getWalletByUserId(int $userId)
    {
        return $this->walletRepository->getWalletByUserId($userId);
    }

    /**
     * Update a wallet
     * @param int $id
     * @param arrray $data
     * @return json response
    */
    public function updateWallet(array $data)
    {
        $walletPayer = $this->walletRepository->getWalletByUserId($data["payer"]);
        $walletPayee = $this->walletRepository->getWalletByUserId($data["payee"]);

        if (!$walletPayer) {
            return response()->json(['message' => 'Payer Not Found'], 404);
        }

        if (!$walletPayee) {
            return response()->json(['message' => 'Payee Not Found'], 404);
        }

       // Verifica se Payer tem saldo sufuciente para essa transação
       $value = (float)$data["value"];
       if ($walletPayer->amount < $value) {
            return response()->json(['message' => 'Payer does not have funds for this transaction'], 422);
       }

       // Remove value do payer e adiciona no Payee
       $walletPayer->amount = $walletPayer->amount - $value;
       $walletPayee->amount = $walletPayee->amount + $value;       

       $this->walletRepository->updateWallet($walletPayer);
       $this->walletRepository->updateWallet($walletPayee);
       return response()->json(['message' => 'Transfer Completed'], 200);
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