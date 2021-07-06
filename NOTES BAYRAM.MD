## Test has problem
* Povil has  seperate lesson https://laraveldaily.teachable.com/p/laravel-phpunit-testing-for-beginners
* I couldnt make test because when I made test it remove all data from database.
* Regarding test i'll get seperate lesson.

 We used Gates https://laravel.com/docs/8.x/authorization#gates
* Test file I couldnt test the permissions.
* Gate defined at app\Providers\AuthServiceProvider.php
* Gate used at article edit and create blade.
* Gate used at app.blade
* At the beginning we have been using role till 2 role after 2 we have to use gate.

## Lesson 6
* Gate are for individiual permission, policy for grouping permissions.
* Gates related to one specific model.
* Policy is realated to model https://laravel.com/docs/8.x/authorization#generating-policies
* Policies created and used for article
