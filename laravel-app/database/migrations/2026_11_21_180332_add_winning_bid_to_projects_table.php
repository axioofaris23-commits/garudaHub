<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->unsignedBigInteger('winning_bid_id')->nullable()->after('status');
            $table->foreign('winning_bid_id')->references('id')->on('bids')->nullOnDelete();
        });

        Schema::table('bids', function (Blueprint $table) {
            $table->unique(['project_id', 'developer_id']);
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bids', function (Blueprint $table) {
            $table->dropUnique(['project_id', 'developer_id']);
        });

        Schema::table('projects', function (Blueprint $table) {
            $table->dropForeign(['winning_bid_id']);
            $table->dropColumn('winning_bid_id');
        });
    }
};
