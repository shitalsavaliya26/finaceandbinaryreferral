<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SupportTicket extends Model
{
    use HasFactory,SoftDeletes;

    
    protected $table = "support_tickets";

    protected $dates = [ 'deleted_at' ];

    public function setSlugAttribute($value)
    {
        $this->attributes['slug'] = uniqid('support-ticket-');
    }
    
    public function subject() {
        return $this->belongsTo(SuportSubject::class, 'subject_id', 'id');
    }
    public function user_detail() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function supportattach() {
        return $this->hasMany(SupportTicketAttachment::class, 'support_tkt_id', 'id')->orderBy('created_at','desc');
    }
    public function last_message() {
        return $this->hasOne(SupportTicketMessages::class, 'support_id', 'id')->latest();
    }
    public function messages() {
        return $this->hasMany(SupportTicketMessages::class, 'support_id', 'id');
    }
}
