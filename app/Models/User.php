<?php
namespace App\Models;

use App\Models\UserBalance;
use App\Models\UserBono;
use App\Models\UserInversion;
use DB;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use TCG\Voyager\Models\Role;
use Wave\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'username',
        'password',
        'verification_code',
        'verified',
        'trial_ends_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'trial_ends_at' => 'datetime',
    ];

    public function misroles()
    {
        return $this->roles()->pluck('name')->toArray();
    }

    public function esPublicista()
    {
        return in_array('publicista', $this->misroles());
    }

    public function referidos($userId)
    {
        return DB::table('referidos')
            ->join('users', 'referidos.user_id', '=', 'users.id')
            ->where('referidos.user_id', $userId)
            ->select('referred_user_id')
            ->get();
    }
    public function referido(): HasMany
    {
        return $this->hasMany(Referido::class, 'user_id', 'id');
    }
    public function referidosEnTresNiveles($userId, $niveles)
    {
        $resultados  = [];
        $actualNivel = [$userId];
        $totales     = 0;
        for ($i = 1; $i <= $niveles; $i++) {
            // Obtener referidos del nivel actual
            $referidos = \DB::table('referidos')
                ->whereIn('user_id', $actualNivel)
                ->pluck('referred_user_id')
                ->toArray();

            // Guardar el nivel actual de referidos en el array de resultados
            $resultados["nivel_$i"] = $referidos;
            $totales += count($referidos);
            // Si no hay más referidos en el nivel actual, romper el bucle
            if (empty($referidos)) {
                break;
            }

            // Actualizar el nivel actual para el próximo ciclo
            $actualNivel = $referidos;
        }

        return $resultados = [
            'referidos' => $resultados,
            'conteo'    => $totales,
        ];

    }
    public function referidoPrincipalHaciaArriba($userId, $niveles)
    {
        $resultados   = [];
        $actualUserId = $userId;

        for ($i = 1; $i <= $niveles; $i++) {
            // Obtener el referido principal (único) en el nivel actual hacia arriba
            $referido = \DB::table('referidos')
                ->where('referred_user_id', $actualUserId)
                ->value('user_id'); // Obtiene un solo user_id que refiere al actual

            // Guardar el usuario referido principal del nivel en el array de resultados
            if ($referido) {
                $resultados["nivel_$i"] = $referido;
            } else {
                // Si no hay más referidos hacia arriba, salir del bucle
                break;
            }

            // Actualizar el actualUserId para el próximo nivel hacia arriba
            $actualUserId = $referido;
        }

        return $resultados;
    }

    public function balance_general()
    {
        return $this->hasOne(UserBalance::class);
    }
    public function balance_bono()
    {
        return $this->hasOne(UserBono::class);
    }
    public function balance_inversion()
    {
        return $this->hasOne(UserInversion::class);
    }
    public function balance_ibox()
    {
        return $this->hasOne(UserIbox::class);
    }
    public function balance_card()
    {
        return $this->hasOne(UserCard::class);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_roles');
    }

}
