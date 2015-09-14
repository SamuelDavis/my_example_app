<?php
use App\Entities\User;

/**
 * @var User $currentUser
 */

?>

<?php if ($currentUser): ?>
<a href="/logout"><button>Logout</button></a>
<?php else: ?>
<a href="/login"><button>Login</button></a>
<?php endif; ?>
<hr>
