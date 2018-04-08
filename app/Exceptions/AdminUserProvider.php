<?php
namespace App\Exceptions;
use Illuminate\Support\Str;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Contracts\Hashing\Hasher as HasherContract;
use Illuminate\Contracts\Auth\Authenticatable as UserContract;

class AdminUserProvider implements UserProvider{
    /**
     * The hasher implementation.
     *
     * @var \Illuminate\Contracts\Hashing\Hasher
     */
    protected $hasher;
    
    /**
     * The Eloquent user model.
     *
     * @var string
     */
    protected $model;
    public function __construct(HasherContract $hasher, $model)
    {
        $this->model = $model;
        $this->hasher = $hasher;
    }
    /**
     * {@inheritDoc}
     * @see \Illuminate\Contracts\Auth\UserProvider::retrieveByCredentials()
     */
    public function retrieveByCredentials(array $credentials)
    {
        // TODO Auto-generated method stub
        if (empty($credentials) ||
            (count($credentials) === 1 &&
                array_key_exists('password', $credentials))) {
                    return;
                }
                
                // First we will add each credential element to the query as a where clause.
                // Then we can execute the query and, if we found a user, return it in a
                // Eloquent User "model" that will be utilized by the Guard instances.
                $query = $this->createModel()->newQuery();
                
                foreach ($credentials as $key => $value) {
                    if (! Str::contains($key, 'password')) {
                        $query->where($key, $value);
                    }
                }
                
                return $query->first();
    }

    /**
     * {@inheritDoc}
     * @see \Illuminate\Contracts\Auth\UserProvider::retrieveById()
     */
    public function retrieveById($identifier)
    {
        // TODO Auto-generated method stub
        $model = $this->createModel();
        
        return $model->newQuery()
        ->where($model->getAuthIdentifierName(), $identifier)
        ->first();
    }

    /**
     * {@inheritDoc}
     * @see \Illuminate\Contracts\Auth\UserProvider::retrieveByToken()
     */
    public function retrieveByToken($identifier, $token)
    {
        // TODO Auto-generated method stub
        $model = $this->createModel();
        
        $model = $model->where($model->getAuthIdentifierName(), $identifier)->first();
        
        if (! $model) {
            return null;
        }
        
        $rememberToken = $model->getRememberToken();
        
        return $rememberToken && hash_equals($rememberToken, $token) ? $model : null;
    }

    /**
     * {@inheritDoc}
     * @see \Illuminate\Contracts\Auth\UserProvider::updateRememberToken()
     */
    public function updateRememberToken(\Illuminate\Contracts\Auth\Authenticatable $user, $token)
    {
        // TODO Auto-generated method stub
        $user->setRememberToken($token);
        
        $timestamps = $user->timestamps;
        
        $user->timestamps = false;
        
        $user->save();
        
        $user->timestamps = $timestamps;
    }

    /**
     * {@inheritDoc}
     * @see \Illuminate\Contracts\Auth\UserProvider::validateCredentials()
     */
    public function validateCredentials(UserContract $admin, array $credentials)
    {
        $plain = $credentials['admin_password'];
        return $this->hasher->check($plain, $admin->getAuthPassword());
    }
    /**
     * Create a new instance of the model.
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function createModel()
    {
        $class = '\\'.ltrim($this->model, '\\');
        
        return new $class;
    }
    
}