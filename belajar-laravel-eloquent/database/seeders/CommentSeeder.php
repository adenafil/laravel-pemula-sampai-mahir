<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Product;
use App\Models\Voucher;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->createCommentForProduct();
        $this->createCommentForVoucher();
    }

    public function createCommentForProduct(): void
    {
        $product = Product::find('1');

        $comment = new Comment();
        $comment->email = 'ade@pzn.co.id';
        $comment->title = 'Title';
        $comment->commentable_id = $product->id;
        $comment->commentable_type = 'product';
        $comment->save();
    }

    public function createCommentForVoucher(): void
    {
        $voucher = Voucher::first();

        $comment = new Comment();
        $comment->email = 'ade@pzn.co.id';
        $comment->title = 'Title';
        $comment->commentable_id = $voucher->id;
        $comment->commentable_type = 'voucher';
        $comment->save();
    }

}
