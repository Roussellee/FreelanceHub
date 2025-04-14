# Read.me for FreelanceHub

<p align="center">
    <a href="https://github.com/yiisoft" target="_blank">
        <img src="https://avatars0.githubusercontent.com/u/993323" height="100px">
    </a>
    <h1 align="center">FreelanceHub - Платформа для фрилансеров и заказчиков</h1>
    <br>
</p>

FreelanceHub - это платформа, которая предоставляет возможность фрилансерам и заказчикам находить и выполнять проекты. Этот проект основан на фреймворке [Yii 2](https://www.yiiframework.com/) и включает в себя основные функции, такие как регистрация пользователей, создание проектов и управление ими.

## Содержание

- [Структура каталога](#структура-каталога)
- [Требования](#требования)
- [Установка](#установка)
- [Диаграммы проекта](#диаграммы-проекта)
- [SEO-оптимизация](#seo-оптимизация)

## Структура каталога

```
assets/             содержит определения ресурсов
commands/           содержит консольные команды (контроллеры)
config/             содержит конфигурации приложения
controllers/        содержит классы веб-контроллеров
mail/               содержит файлы представлений для электронной почты
models/             содержит классы моделей
runtime/            содержит файлы, созданные во время выполнения
tests/              содержит различные тесты для базового приложения
vendor/             содержит зависимые сторонние пакеты

views/              содержит файлы представлений для веб-приложения
views/site/         содержит представления для главной страницы, авторизации, регистрации
views/project/      содержит представления для взаимодействия с проектами
views/task/         содержит представления для взаимодействия с задачами проекта
views/application/  содержит представления для взаимодействия с заявками на участие в проекте
views/client/       содержит представления для взаимодействия с профилем клиента, его проектами, заявками проектов
views/freelancer/   содержит представления для взаимодействия с активных проектах фрилансера и его профиля
web/                содержит входной скрипт и веб-ресурсы
web/uploads/        содержит все сохраненные файлы проектов и заданий
```

## Требования

- Минимальные требования: PHP 8.1.9 и выше.
- Yii2 (2.0.49) и выше.

## Установка

### Установка из GitHub

Извлеките скачайте проект, загруженный с [github/Roussellee](https://github.com/Roussellee/FreelanceHub/), в директорию с именем `freelancehub`, которая находится непосредственно под корнем веб-сервера.

Установите ключ валидации cookie в файле `config/web.php` на случайную строку:

```php
'request' => [
    'cookieValidationKey' => '<секретная случайная строка>',
],
```

Теперь вы сможете получить доступ к приложению по следующему URL:

```bash
http://localhost/freelancehub/web/
```

### Конфигурация базы данных

Отредактируйте файл `config/db.php`, указав реальные данные, например:

```php
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=your_db_name',
    'username' => 'your_username',
    'password' => 'your_password',
    'charset' => 'utf8',
];
```
Откройте папку с проектом в терминали и введите команду `php yii migrate` для создания миграций в базе данных.
Запустите свой проект через терминал `php yii serve` и можете пользоваться.

## Диаграммы проекта
### Диаграмма UseCase
[![Use-Case-New.png](https://i.postimg.cc/KYDfbsgX/Use-Case-New.png)](https://postimg.cc/nsMBY2kT)
### ER-диаграмма
[![Er-Diagramm.png](https://i.postimg.cc/ydfTggPv/Er-Diagramm.png)](https://postimg.cc/PpwD0q0w)

## SEO-оптимизация
### Оптимизация мета-тегов
Оптимизация заголовков, описания и ключевых слов происходит с помощью: Оптимизация заголовков - `$this->title = $перменная->title;` или `$this->title = '';`, оптимизация описания - `$this->registerMetaTag(['name' => 'description', 'content' => $this->title]);`, оптимизация ключевых слов - `$this->registerMetaTag(['name' => 'keywords', 'content' => $this->title]);`

### Структура URL
```
'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '' => 'site/index',                                                 Главная страница 
                'login' => 'site/login',                                            Страница авторизации
                'register' => 'site/register',                                      Страница регистрации
                'logout' => 'site/logout',                                          Страница выхода из аккаунта  

                'freelancer/profile/<username:\w+>' => 'freelancer/profile',        Профиль фрилансера
                'client/profile/<username:\w+>' => 'client/profile',                Профиль заказчика
                'freelancer/edit' => 'freelancer/edit',                             Редактирование профиля заказчика   
                'freelancer/applications' => 'project/applications',                Страница с заявками, которые подал фрилансер на участие в проектах
                'client/edit' => 'client/edit',                                     Редактирование профиля клиента
                'client' => 'client/index',                                         Страница с проектами и заявками заказчика   

                'project' => 'project/index',                                        Страница проектов
                'project/create' => 'project/create',                                Страница создания проекта
                'project/<slug>' => 'project/view',                                  Страница отдельного проекта
                'project/update/<slug>' => 'project/update',                         Страница обновления проекта   
                'project/delete/<slug>' => 'project/delete',                         Страница удаления проекта
                'project/complete/<slug>' => 'project/complete',                     Страница завершения проекта (для фрилансера)

                'project/<projectSlug>/task/create' => 'task/create',                Страница создания задачи для проекта
                'project/<projectSlug>/task/<slug>' => 'task/view',                  Просмотр страницы задачи
                'project/<projectSlug>/task/<slug>/update' => 'task/update',         Страница изменения задачи
                'project/<projectSlug>/task/<slug>/delete' => 'task/delete',         Удаление задачи
                'project/<projectSlug>/task/<slug>/complete' => 'task/complete',     Страница для завершения задачи (для фрилансера)

                'project/<projectSlug>/application/create' => 'application/create',  Страница для создания заявки на участие в проекте  
                'project/<projectSlug>/applications' => 'project/applications',      Все заявки одного проекта  
                'application/<slug>' => 'application/view',                          Просмотр заявки
                'application/<slug>/accept' => 'application/accept',                 Url для принятия заявки на участие в проекте
                'application/<slug>/reject' => 'application/reject',                 Url для отклонения заявки на участие в проекте
                'application/<slug>/delete' => 'application/delete',                 Url для удаления заявки (для фрилансера)


            ],
        ],
```

Структура URL была сделана для ЧПУ, которая делает более понятным URL для пользователей сайта. У большинства URL есть `<slug>`, который сделан из уникального, генерируемого title.
Код, с помощью которого это все делают
`models/useTrait.php`
```
public function generateUniqueSlug($title)
    {
        // Транслитерация кириллицы в латиницу
        $transliteratedTitle = $this->transliterate($title);

        // Создание slug из транслитерированного заголовка
        $slug = Inflector::slug($transliteratedTitle);
        $baseSlug = $slug;
        $counter = 1;

        // Проверка уникальности slug
        while (static::find()->where(['slug' => $slug])->exists()) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    private function transliterate($string)
    {
        $transliterationTable = [
            'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G', 'Д' => 'D',
            'Е' => 'E', 'Ё' => 'Yo', 'Ж' => 'Zh', 'З' => 'Z', 'И' => 'I',
            'Й' => 'Y', 'К' => 'K', 'Л' => 'L', 'М' => 'M', 'Н' => 'N',
            'О' => 'O', 'П' => 'P', 'Р' => 'R', 'С' => 'S', 'Т' => 'T',
            'У' => 'U', 'Ф' => 'F', 'Х' => 'Kh', 'Ц' => 'Ts', 'Ч' => 'Ch',
            'Ш' => 'Sh', 'Щ' => 'Shch', 'Ъ' => '', 'Ы' => 'Y', 'Ь' => '',
            'Э' => 'E', 'Ю' => 'Yu', 'Я' => 'Ya',
            'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd',
            'е' => 'e', 'ё' => 'yo', 'ж' => 'zh', 'з' => 'z', 'и' => 'i',
            'й' => 'y', 'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n',
            'о' => 'o', 'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't',
            'у' => 'u', 'ф' => 'f', 'х' => 'kh', 'ц' => 'ts', 'ч' => 'ch',
            'ш' => 'sh', 'щ' => 'shch', 'ъ' => '', 'ы' => 'y', 'ь' => '',
            'э' => 'e', 'ю' => 'yu', 'я' => 'ya',
            // Дополнительные символы
            ' ' => '-', '.' => '', ',' => '', '!' => '', '?' => '',
            ':' => '', ';' => '', '"' => '', "'" => '', '(' => '',
            ')' => '', '[' => '', ']' => '', '{' => '', '}' => '',
            // Удаляем все символы, которые не буквы или цифры
        ];

        return strtr($string, $transliterationTable);
    }
```
Пример использования в модели:
Возьмем модель Project. Необходимо вставить код в модель Project, а также добавить в таблицу Project, поле slug. 
```
use SlugTrait;
public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                // Генерация уникального slug
                $this->slug = $this->generateUniqueSlug($this->title);
            }
            return true;
        }
        return false;
    }
```
Теперь при создании записи в таблице Project, поле `<slug>` будет автоматически генерироваться, на основе поля `title`.

###Оптимизация robots.txt
Были оптимизированны robots.txt, чтобы не индексировались системные папки.
```
User -agent: *

# Запретить индексацию папок, которые не должны быть доступны
Disallow: /assets/
Disallow: /web/assets/
Disallow: /web/css/
Disallow: /web/fonts/
Disallow: /web/uploads/
Disallow: /models/
Disallow: /controllers/
Disallow: /views/
Disallow: /config/
Disallow: /vendor/
Disallow: /migrations/
Disallow: /mail/
Disallow: /vagrant/
Disallow: /web/robots.txt  # Запретить доступ к самому файлу robots.txt
```
