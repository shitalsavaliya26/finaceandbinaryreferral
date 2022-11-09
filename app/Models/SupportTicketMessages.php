<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupportTicketMessages extends Model
{
    use HasFactory;
    protected $table = "support_ticket_messages";

      //belong to ticket
    public function tickets() {
        return $this->belongsTo(SupportTicket::class, 'support_id', 'id');
    }
    //attchment 
    public function attchment() {
        return $this->hasMany(SupportTicketAttachment::class, 'message_id', 'id');
    }
}
