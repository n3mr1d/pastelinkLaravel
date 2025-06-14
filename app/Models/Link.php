<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
class Link extends Model
{
    use HasFactory;

    protected $table = "links";
    protected $fillable = [
        "link", "title", "postby", "catagory"
    ];

    /**
     * Get the user that posted the link.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'postby');
    }
}
