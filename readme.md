### 安装
```$xslt
"composer require lazycao/aliyun-oss:^1.0"

"lazycao/aliyun-oss": "^1.0"
```

### 配置文件
```$xslt
'disks'=>[
    ...
    
    'oss' => [
        'driver'        => 'oss',
        'access_id' => env('OSS_ACCESS_KEY'),
        'access_key' => env('OSS_SECRET_KEY'),
        'endpoint'   => env('OSS_ENDPOINT'), // 使用 ssl 这里设置如: https://oss-cn-beijing.aliyuncs.com
        'bucket'     => env('OSS_BUCKET'),
        'isCName'    => env('OSS_IS_CNAME', false), // 如果 isCname 为 false，endpoint 应配置 oss 提供的域名如：`oss-cn-beijing.aliyuncs.com`，否则为自定义域名，，cname 或 cdn 请自行到阿里 oss 后台配置并绑定 bucket
        'cdnDomain'   => env("OSS_CDN_URL"),
        'prefix' => ''
    ],
    ...
]
```

### 使用
```$xslt
Storage::disk('oss'); // if default filesystems driver is oss, you can skip this step

//fetch all files of specified bucket(see upond configuration)
Storage::files($directory);
Storage::allFiles($directory);

Storage::put('path/to/file/file.jpg', $contents); //first parameter is the target file path, second paramter is file content
Storage::putFile('path/to/file/file.jpg', 'local/path/to/local_file.jpg'); // upload file from local path

Storage::get('path/to/file/file.jpg'); // get the file object by path
Storage::exists('path/to/file/file.jpg'); // determine if a given file exists on the storage(OSS)
Storage::size('path/to/file/file.jpg'); // get the file size (Byte)
Storage::lastModified('path/to/file/file.jpg'); // get date of last modification

Storage::directories($directory); // Get all of the directories within a given directory
Storage::allDirectories($directory); // Get all (recursive) of the directories within a given directory

Storage::copy('old/file1.jpg', 'new/file1.jpg');
Storage::move('old/file1.jpg', 'new/file1.jpg');
Storage::rename('path/to/file1.jpg', 'path/to/file2.jpg');

Storage::prepend('file.log', 'Prepended Text'); // Prepend to a file.
Storage::append('file.log', 'Appended Text'); // Append to a file.

Storage::delete('file.jpg');
Storage::delete(['file1.jpg', 'file2.jpg']);

Storage::makeDirectory($directory); // Create a directory.
Storage::deleteDirectory($directory); // Recursively delete a directory.It will delete all files within a given directory, SO Use with caution please.

// upgrade logs
// new plugin for v2.0 version
Storage::putRemoteFile('target/path/to/file/jacob.jpg', 'http://example.com/jacob.jpg'); //upload remote file to storage by remote url
// new function for v2.0.1 version
Storage::url('path/to/img.jpg') // get the file url
```