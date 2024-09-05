<?php

namespace App\Repositories\Contracts;

use App\Models\Wallet;

interface WalletRepositoryInterface
{
    public function getAllWallets();
    public function getWalletById($id);
    public function getWalletByUserId($userId);
    public function createWallet(array $data);
    public function updateWallet(Wallet $wallet);
    public function destroyWallet(Wallet $wallet);
}