## artisan

- php artisan migrate

- php artisan migrate:rollback

- select

```

$data = DB::table('articles')
            ->select('category_id', 'title', 'content')
            ->where('title', '<>', '文章1')
            ->whereIn('id', [1, 2, 3])
            ->groupBy('category_id')
            ->orderBy('id', 'desc')
            ->limit(1)
            ->get();
        dump($data);

        

```
