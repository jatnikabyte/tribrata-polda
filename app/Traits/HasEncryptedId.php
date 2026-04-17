<?php

namespace App\Traits;

use Illuminate\Contracts\Encryption\DecryptException;

trait HasEncryptedId
{
    // Getter: ubah ID jadi terenkripsi di setiap access
    public function getEncryptedIdAttribute()
    {
        return encryptID($this->attributes['id']);
    }

    // Opsional: override route binding Laravel (misal /perfumes/{id})
    public function resolveRouteBinding($value, $field = null)
    {
        try {
            $id = decryptID($value);
        } catch (DecryptException $e) {
            abort(404, 'Invalid encrypted ID');
        }

        return $this->where('id', $id)->firstOrFail();
    }

    // Utility function: untuk manual decrypt ID (misal di service)
    public static function decryptId($encryptedId)
    {
        try {
            return decryptID($encryptedId);
        } catch (DecryptException $e) {
            throw new \InvalidArgumentException('Invalid encrypted ID');
        }
    }
}
