<?php

    namespace App\Policies;

    use App\Models\User;
    use Illuminate\Auth\Access\Response;

    class UserPolicy
    {
        public function manageUsers(User $currentUser): bool
        {
            // e.g. only admins
            return $currentUser->hasRole('admin');
        }

        /**
         * Determine whether the user can view any models.
         */
//        public function viewAny(User $user): bool
//        {
//            //
//        }

        /**
         * Determine whether the user can view the model.
         */
//        public function view(User $user, User $model): bool
//        {
//            //
//        }

        /**
         * Determine whether the user can create models.
         */
//        public function create(User $user): bool
//        {
//            //
//        }

        /**
         * Determine whether the user can update the model.
         */
//        public function update(User $user, User $model): bool
//        {
//            //
//        }

        /**
         * Determine whether the user can delete the model.
         */
//        public function delete(User $user, User $model): bool
//        {
//            //
//        }
    }
