<?php

namespace App\Repositories;

use App\Repositories\Contracts\WalletRepositoryInterface;
use App\Models\Wallet;

class WalletRepository implements WalletRepositoryInterface
{
    protected $entity;

    public function __construct(Wallet $wallet)
    {
        $this->entity = $wallet;
    }

    /**
     * Get all Wallets
     * @return array
     */
    public function getAllWallets()
    {
        return $this->entity->all();
    }
    
    /**
     * Select Wallet by ID
     * @param int $id
     * @return object
     */
    public function getWalletById($id)
    {
        return $this->entity->find($id);
    }

    /**
     * Select Wallet by User ID
     * @param int $id
     * @return object
     */
    public function getWalletByUserId($userId)
    {
        return $this->entity->where("user_id", $userId)->first();
    }

    /**
     * Create a new wallet
     * @param array $data
     * @return object
     */
    public function createWallet(array $data)
    {
        return $this->entity->create($data);
    }

     /**
     * Update data of wallet
     * @param object $wallet
     * @param array $data
     * @return object
     */
    public function updateWallet(Wallet $wallet)
    {
        return $wallet->save();
    }

    /**
     * Delete a wallet
     * @param object $wallet
     */
    public function destroyWallet(Wallet $wallet) 
    {
        return $wallet->delete();
    }
}