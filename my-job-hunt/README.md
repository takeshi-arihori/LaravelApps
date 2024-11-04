# Job Search App

ユーザーがジョブに応募したり、ジョブを投稿したりできるアプリケーションの作成

## 作成手順

### モデルの作成
```zsh
php artisan make:model JobListing --all
```

### マイグレーションファイルの作成
```zsh
    Schema::create('job_listings', function (Blueprint $table) {
        $table->id();
        $table->string('title')->unique();
        $table->string('company');
        $table->text('description');
        $table->string('location');
        $table->string('type');
        $table->decimal('salary', 8, 0);
        $table->datetime('application_deadline');
        $table->timestamps();
    });
```

### ファクトリーの作成

- `php artisan migrate`
マイグレーションの実行でテーブルを作成

**tinkerでテスト**  

- `php artisan tinker`  

```zsh

> $jobTest = App\Models\JobListing::create([                                                                                                                                              'title' => 'Software Engineer',                                                                                                                                                         'company' => 'Tech Innovators',                                                                                                                                                         'description' => 'Develop and maintain software applications.',                                                                                                                         'location' => 'San Francisco, CA',                                                                                                                                                      'type' => 'Full-time',                                                                                                                                                                  'salary' => 120000,                                                                                                                                                                     'application_deadline' => '2024-12-31T23:59:59'                                                                                                                                       ]);


## 結果

= App\Models\JobListing {#5299
    title: "Software Engineer",
    company: "Tech Innovators",
    description: "Develop and maintain software applications.",
    location: "San Francisco, CA",
    type: "Full-time",
    salary: 120000,
    application_deadline: "2024-12-31T23:59:59",
    updated_at: "2024-11-03 01:17:33",
    created_at: "2024-11-03 01:17:33",
    id: 1,
  }

> $jobTest->title;
= "Software Engineer"

> $jobTest->type;
= "Full-time"

> $jobTest->location;
= "San Francisco, CA"

> $jobTest->salary;
= 120000

```

**JobListingFactory.php**  
```
    public function definition(): array
    {
        return [
            'title' => fake()->unique()->word,
            'company' => fake()->word,
            'description' => fake()->text,
            'location' => fake()->word,
            'type' => fake()->word,
            'salary' => fake()->numberBetween(10000, 1000000),
            'application_deadline' => fake()->dateTime(),
        ];
    }
```

**php artisan tinkerにてテスト**  

- テスト1
```zsh
$randomJobs = App\Models\JobListing::factory()->make();

## 結果
= App\Models\JobListing {#5293
    title: "natus",
    company: "aspernatur",
    description: "Error deleniti enim ducimus quod provident fugit. In aut doloremque id pariatur non dolor. Pariatur eligendi est occaecati ut aut ipsa eligendi. Magni illum ut ullam odio.",
    location: "impedit",
    type: "ipsum",
    salary: 588497,
    application_deadline: DateTime @1033318430 {#5291
      date: 2002-09-29 16:53:50.0 UTC (+00:00),
    },
  }
```

- テスト2 複数のデータを作成
```zsh
$randomJobs = App\Models\JobListing::factory()->count(5)->make();
```

### シーディングの作成

**config/models/seeding/jobListing.php**  

```zsh

```

**シーディングのテスト**  

```zsh
php artisan db:seed 
```