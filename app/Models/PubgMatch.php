<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PubgMatch extends Model
{
    use HasFactory;

    /**
     * আপনার ডাটাবেস প্রিফিক্স অনুযায়ী টেবিল নাম সেট করা।
     * যদি টেবিলের নাম 'aerox_pubg' হয় তবে নিচেরটি ব্যবহার করুন।
     * আর যদি 'pubg_matches' হয় তবে সেটি লিখুন।
     */
    protected $table = 'aerox_pubg'; 

    /**
     * আপনার টেবিলে created_at এবং updated_at কলাম নেই, 
     * তাই এটি অবশ্যই false রাখতে হবে। নাহলে এরর আসবে।
     */
    public $timestamps = false;

    /**
     * প্রাইমারি কি 'id'
     */
    protected $primaryKey = 'id';

    /**
     * মাস অ্যাসাইনমেন্টের জন্য কলামগুলোর লিস্ট।
     */
    protected $fillable = [
        'Match_Key',
        'Match_Title',
        'Match_Time',
        'Total_Prize',
        'prize_1st',
        'prize_2nd',
        'prize_3rd',
        'Per_Kill',
        'Entry_Fee',
        'Entry_Type',
        'Match_Type',
        'Version',
        'Play_Map',
        'Player_Need',
        'Player_Join',
        'Room_ID',
        'Room_Pass',
        'Position',
    ];

    /**
     * ডাটা টাইপ কাস্টিং।
     * এটি Match_Time কে কার্বন (Carbon) অবজেক্টে রূপান্তর করবে।
     */
    protected $casts = [
        'Match_Time' => 'datetime',
    ];
}