<?php

namespace App\Console\Commands;

use App\Events\BookExpired;
use App\Models\Book;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Builder;

class CheckBookExpirations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'books:check-expirations';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check expired books and trigger BookExpired event';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $expiredBooks = Book::whereHas('issuedBook', function (Builder $query) {
            $query->where('due_date', '<', now());
        })->get();

        foreach ($expiredBooks as $book) {
            event(new BookExpired($book));
        }

        $this->info('Book expiration check completed');
    }
}
