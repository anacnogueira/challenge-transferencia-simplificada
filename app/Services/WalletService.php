<?php

namespace App\Services;
use App\Repositories\Contracts\WalletRepositoryInterface;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\ConnectionException;
use App\Notifications\TransactionCompleted;

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

        $value = (float)$data["value"];
        if ($walletPayer->amount < $value) {
            return response()->json(['message' => 'Payer does not have funds for this transaction'], 422);
        }

        //$response = $this->autorizeTransfer();

        // if ($response === null) {
        //     throw new \Exception('Unsuccessful response from the Authorization API.');
        // }

        $response["data"]["authorization"] = true;
        
        if ($response["data"]["authorization"]) {
            $walletPayer->amount = $walletPayer->amount - $value;
            $walletPayee->amount = $walletPayee->amount + $value;

            $this->walletRepository->updateWallet($walletPayer);
            $this->walletRepository->updateWallet($walletPayee);

            $walletPayee->user->notify(new TransactionCompleted($value, $walletPayer->user->name));

            return response()->json(['message' => 'Transfer Completed'], 200);
        }
        
        return response()->json(['message' => 'Transfer Not Authorized'], 422);
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

    private function autorizeTransfer()
    {
        $url = 'https://util.devi.tools/api/v2/authorize';
         
        try {
            $response = Http::timeout(120)->get($url);
            if ($response->successful()) {
                return $response->json();
            }
        } catch (ConnectionException $e) {
            throw new \Exception('Unsuccessful response from the Authorization API.');
        }
    }
}