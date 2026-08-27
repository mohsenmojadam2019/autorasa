<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RetailDocumentSubmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'national_code',
        'trace_code',
        'document_number',
        'register_date',
        'postal_code',
        'raw_response',
    ];

    protected $casts = [
        'raw_response' => 'array', // برای تبدیل داده‌های JSON به آرایه
    ];

    /**
     * Get the user associated with the RetailDocumentSubmission.
     */
    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }
}
