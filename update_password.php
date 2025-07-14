<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';

$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

try {
    $user = App\Models\User::where('email', 'admin@admin.com')->first();
    
    if ($user) {
        $user->password = bcrypt('password');
        $user->save();
        echo "Password updated for admin@admin.com\n";
        echo "You can now login with:\n";
        echo "Email: admin@admin.com\n";
        echo "Password: password\n";
    } else {
        echo "User not found\n";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
