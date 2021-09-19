# deadline
締め日を取得する

## Install
利用するプロジェクトの `composer.json` に以下を追加する。
```composer.json
"repositories": {
    "deadline": {
        "type": "vcs",
        "url": "https://github.com/shimoning/deadline.git"
    }
},
```

その後以下でインストールする。

```bash
composer require shimoning/deadline
```

## Usage

### Deadline
締め日を取得する

```php
$deadline = new Deadline(2020, 4, 20);

// TODO: write

// get deadline
$deadline->get();

// set hour
$deadline->get(12);

// set hour and minute
$deadline->get(12, 30);

// set hour, minute and second
$deadline->get(11, 59, 59);

// get exceeded
$deadline->exceeded();
```

## Options

### Holidays
#### 祝日を設定する
```php
$deadline->setHolidays(['2021-09-20', Carbon::parse('2021-09-23')]);
```

#### 祝日か判定する
```php
$deadline->isHoliday(); // true or false
```

### Weekend
#### 週末を設定する
```php
$deadline->setWeekendDays([Carbon::SUNDAY])
```

### 週末か判定する。
```php
$deadline->isWeekend(); // true or false
```

### If not weekday
平日じゃない場合の振る舞い。
#### 設定する
```php
$deadline->setBehaviorIfNotWeekday(1);  // 次の日にずらす
$deadline->setBehaviorIfNotWeekday(-1);  // 前の日にずらす
```

例) 対象日が 2021-09-05 (日) かつ、週末設定が土日の場合。
`1` を設定すると、 2021-09-06 (月) になる。
`-1` を設定すると、 2021-09-03 (金) になる。

### 基準日の設定
```php
// 1日
$deadline->setBaseDay(1);

// 末日
$deadline->setBaseDay('t');
```
