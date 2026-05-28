<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();
$conv = App\Models\Conversation::first();
Auth::loginUsingId($conv->buyer_id);
$html = view('chat.show', ['conversation' => $conv])->render();
$pos = strpos($html, 'wire:snapshot');
if ($pos !== false) {
    echo substr($html, max(0, $pos - 200), 1000);
} else {
    echo "NO wire:snapshot FOUND!\n";
    
    // Check if the component div is there at all
    $pos2 = strpos($html, 'id="chat-container"');
    if ($pos2 !== false) {
        echo "Found chat-container at pos $pos2\n";
        echo substr($html, max(0, $pos2 - 500), 1000);
    } else {
        echo "No chat-container either!\n";
    }
}
