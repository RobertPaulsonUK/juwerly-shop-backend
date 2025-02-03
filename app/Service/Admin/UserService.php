<?php

    namespace App\Service\Admin;

    use App\Jobs\SendUserPassword;
    use App\Models\User;
    use Illuminate\Auth\Events\Registered;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Hash;
    use Illuminate\Support\Str;

    class UserService
    {

        public function store(array $data):User
        {
            try {
               DB::beginTransaction();
               $password = Str::password();
                $data['password'] = Hash::make($password);
                $user = User::create($data);
                SendUserPassword::dispatch($data['email'],$password);
                event(new Registered($user));
               DB::commit();
            } catch (\Exception $exception)
            {
                DB::rollBack();
                abort(404);
            }
            return $user;
        }

        public function update(array $data, User $entity):User
        {
            try {
                DB::beginTransaction();
                $entity->update($data);
                $entity->fresh();
                DB::commit();
            }
            catch ( \Exception $exception) {
                DB::rollBack();
                abort(404);
            }
            return $entity;
        }
    }
