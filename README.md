
# GestorArchivos (MinIO)

Servicio para manejar archivos en MinIO y local en API's Sisoft.




## 🏗️ Deployment

Para que funcione bien el servicio debe asegurarse de tener configurado las variables de entorno y los discos correctamente.

#### Variables de entorno
Estas son variables que se utilizarán en los discos para retornar la url del archivo con el alias de apache cuando se estén utilizando rutas de docsAPP/...

Aquí deben configurarsen las URL de las aplicaciones

`APP_URL_FINANZAS`
`APP_URL_CONTRACTVS`
`APP_URL_CONTRATISTA`
`APP_URL_SIGD`

En `config/filesystems.php` deben estar los siguientes discos configurados:
```php
'ctvMinio' => [
    'driver' => 'local',
    'root' => base_path('../docsAPP'),
    'url' => env('APP_URL_CONTRACTVS'),
],
'contratistaMinio' => [
    'driver' => 'local',
    'root' => base_path('../docsAPP'),
    'url' => env('APP_URL_CONTRATISTA'),
],
'finanzasMinio' => [
    'driver' => 'local',
    'root' => base_path('../docsAPP'),
    'url' => env('APP_URL_FINANZAS'),
],
'sigdMinio' => [
    'driver' => 'local',
    'root' => base_path('../docsAPP'),
    'url' => env('APP_URL_SIGD'),
],
```



## ℹ️ API Reference

#### Obtener bucket configurado
`string` Retorna nombre de bucket
```bash
  getMinioBucket()
```

#### getter estado minIO
`bool` Retorna el estado de minIO en la aplicación.
```bash
  getS3MinioStatus()
```


#### Getter/setter alias apache de docsAPP
 `String`  Retorna el nombre del alias. **Por defecto es documents**
```bash
  getAliasDocs()
```
Cambiar el alias que está por defecto (documents)
```bash
  setAliasDocs()
```
| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `$aliasDocs`      | `string` | **Required**. Nombre alias. |


#### Getter/setter folder minIO
-Esta carpeta se usa para referenciar el destino en minIO.

 `String`  Retorna el nombre de la carpeta de minio que se haya parametrizado en el objeto. 
```bash
  getFolderMinio()
```
Cambiar la carpeta FolderMinio.
```bash
  setFolderMinio($folderMinio)
```
| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `$folderMinio`      | `string` | **Required**. Nombre de la carpeta. |

#### Getter/setter disco local
-Este disco se usa para gestionar archivos cuando el minio esté desactivado.

 `String`  Retorna el nombre del disco prarametrizado en el objeto. 
```bash
  getLocalDisk()
```
Cambiar disco local
```bash
  setLocalDisk($localDisk)
```
| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `$localDisk`      | `string` | **Required**. Nombre del disco (debe existir en filesystems.php)|

#### 📦️Guardar un archivo
Guarda un archivo en local o minio dependiendo de su estado activo.
```bash
  saveFile(string|UploadedFile $file, string $folder, array  $options)
```
| Parameter | Type     | Description |
| :-------- | :------- | :---------- |
| `$file`   | `string`,`UploadedFile`| **Required**. ruta o archivo a guardar)|
|`$folder` | `string` | **Required**. carpeta minio|
|`$options` | `array` | **Optional**. opciones de guardado. (Aplica estos efectos: storage, delete, newName) |

`Array` Datos de retorno

| Return Data | Type     | Description |
| :-------- | :------- | :---------- |
| `path`   | `string`|ruta relativa|
|`url` | `string` | ruta absoluta|
|`name` | `string` | nombre del archivo |
|`publicUrl` | `string` | url pública|


#### 👁️‍🗨️️ Obtener un archivo
Este método está depreciado, en su lugar usa **showFile()**

Devuelve la ruta del archivo para mostrar. No confundir con `downloadFile()`

`getFile(string $path, string $disk, string $folderMinio)`

| Parameter | Type     | Description |
| :-------- | :------- | :---------- |
| `$path`   | `string`| **Required**. ruta del archivo a obtener|
|`$disk` | `string` | **Required**. Nombre del disco|
|`$folderMinio` | `string` | **Optional**. Carpeta destino de minio|

`Array` Datos de retorno

| Return Data | Type     | Description |
| :-------- | :------- | :---------- |
|`from` | `bool` | `true` si viene de minio |
|`exists` | `bool` | `true` si existe el archivo |
|`url` | `string` | ruta del archivo |

Devuelve la ruta del archivo para mostrar. No confundir con `downloadFile()`

`showFile(string $path, array $options)`

| Parameter | Type     | Description |
| :-------- | :------- | :---------- |
| `$path`   | `string`| **Required**. ruta del archivo a obtener|
|`$options` | `array` | **Optional**. Nombre del disco (aplica efectos de storage)|


`Array` Datos de retorno


| Return Data | Type     | Description |
| :-------- | :------- | :---------- |
| `fromCloud`   | `bool`| si viene de minio o local|
|`exists` | `bool` | si el archivo existe en minio o local|
|`path` | `string` | ruta de entrada|
|`url` | `string` | ruta absoluta|
|`publicUrl` | `string` | url pública|

### 📥️ Descargar/mover un archivo a local

Este método permite mover o descargar un archivo de minio a local, cuando el almacenamiento en la nube está activado.

Cuando Minio está desactivado retornará el archivo mismo que está en local.

`downloadFile(string $path, array $options)`


| Parameter | Type     | Description |
| :-------- | :------- | :---------- |
| `$path`   | `string`| **Required**. ruta del archivo a descargar|
|`$options` | `array` | **Optional**. Opciones (aplica estos efectos: storage, ignoreExists, delete)|

`array` Datos de retorno

| Return Data | Type     | Description |
| :-------- | :------- | :---------- |
| `local`   | `bool`| si viene de minio o local|
|`exists` | `bool` | si el archivo existe en minio o local|
|`path` | `string` | ruta de entrada|
|`url` | `string` | ruta absoluta|

### ❎️ Eliminar un archivo

elimina uno o varios archivo si existen

`deleteFile(string|array $path, array $options)`

| Parameter | Type     | Description |
| :-------- | :------- | :---------- |
| `$path`   | `string` `array` | **Required**. ruta del archivo. Se pueden enviar varias rutas en un array unideimensional|
|`$options` | `array` | **Optional**. Opciones (aplica estos efectos: storage)|

`void` Datos de retorno

### 📗️📗️ Copiar/Mover un archivo

Este método permite copiar un archivo de una carpeta a otra
