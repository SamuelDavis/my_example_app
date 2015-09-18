<?php
use App\Entities\User;use App\Route;

/**
 * @var User $currentUser
 */

?>

<?php if ($currentUser): ?>
<a href="<?= Route::to(Route::LOGOUT) ?>">
    <button>Logout</button>
</a>
<?php else: ?>
<a href="<?= Route::to(Route::LOGIN_GET) ?>">
    <button>Login</button>
</a>
<a href="<?= Route::to(Route::REGISTER_GET) ?>">
    <button>Register</button>
</a>
<?php endif; ?>
<hr>
