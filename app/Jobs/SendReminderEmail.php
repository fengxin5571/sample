<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;
use App\Models\User;

class SendReminderEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $email;
    protected $user;
    public function __construct(User $user)
    {
        //
        //$this->email=$email;
        $this->user=$user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
//         //
        $view = 'emails.confirm';
        $to = $this->user->email;
        $subject = "感谢注册 Sample 应用！请确认你的邮箱。";
        Mail::send($view,['user'=>$this->user],function($message)use($to,$subject){
            $message->to($to)->subject($subject);
        });
    }
}
