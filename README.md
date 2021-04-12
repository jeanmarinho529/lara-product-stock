## Sobre
Um simples projeto construído em Laravel 8. De castro de usuários, produtos e categorias.
## Features

- Auth;
- Crud de produtos;
- Movimentação de quantidade produtos;
- Envio de email, quando a quantidade mínima de produtos for atingida;
- Crud de categorias;
- Listagem de estados brasileiro;

## Camadas utilizadas
- Service
- Repository
- Interface 
- Request Validation
- API Resources
- ACL
- Mail
- Factory
- Job
- Queue
- Command

## Instalação
Instalando dependências: 
```sh
$ cd lara-product-stock
$ composer install
```
Criando um .env e gerando  key da sua aplicação:
```sh
$ cp .env.example .env
$ php artisan key:generate
```
Execute migration e popule seu banco de dados:
```sh
$ php artisan migrate
$ php artisan db:seed
```
Execute o comando para popular a tabela states, [consumindo da api do IBGE](https://servicodados.ibge.gov.br/api/v1/localidades/estados):
```sh
$ php artisan command:popular-state
```
Execute o comando para popular a tabela de categories, [consumindo da api do Mercado Livre](https://api.mercadolibre.com/sites/MLB/categories):
```sh
$ php artisan command:popular-category
```
Execute os teste para ver se tudo está ok:
```sh
$ ./vendor/bin/phpunit
```
Por fim execute a aplicação:
```sh
$ php artisan serve
```
## Códigos de Retorno
- ### Lista de Códigos de Sucesso

|  Http | Descrição   | Método HTTP |
| :------------: | :------------: | :------------: |
| 200 | Sucesso                          | GET e POST   |
| 201 | Criado com sucesso               | POST         |
| 204 | Alterado ou excluído com sucesso | PUT e DELETE |

- ### Lista de Códigos de Erro
|  Http | Descrição |
| :------------: | :------------: |
| 400 | Bad Request                     | 
| 401 | Requisição Requer Autenticação  | 
| 403 | Requisição Negada               | 
| 404 | Recurso não Encontrado          |
| 405 | Método não Permitido            |
| 409 | Conflito com a regra de negócio |
| 500 | Erro de servidor                |

## [End Point](https://laraproductapi.docs.apiary.io/#reference/0/rotas-publicas/listar-todos-os-produtos)
- ### End Point publicos
|  Method | Route   | Ação  |
| :------------: | :------------: | :------------: |
| post | /api/v1/auth/register    | Registrar novo usuário               |
| post | /api/v1/auth/login       | Login                                |
| get  | /api/v1/states           | Lista todos os estados Brasileiros   |
| get  | /api/v1/categories       | Lista todas as categorias            |
| get  | /api/v1/categories/{id}  | Lista apenas a categoria escolhida   |
| get  | /api/v1/categories/{id}  | Lista apenas o categoria escolhida   |
| get  | /api/v1/products         | Lista todos os produtos              |
| get  | /api/v1/products/{id}    | Lista apenas o produto escolhido     |

- ### End Point Authentication
|  Method | Route   | Ação  |
| :------------: | :------------: | :------------: |
| post  | /api/v1/auth/logout              | Fazer logout                                  |
| post  | /api/v1/categories               | Registrar nova categoria                      |
| post  | /api/v1/products                 | Registrar novo produto                        |
| post  | /api/v1/products/movement/{slug} | Retirar ou adicionar quantidade de um produto |
| put   | /api/v1/products/{slug}          | Editar um produto                             |
| delete| /api/v1/products/{slug}          | Excluir um produto                            |
###### Obs:  Apenas usuários proprietários ou admin podem editar ou deletar o produto. 

- ### End Point Authentication + Middleware
|  Method | Route   | Ação  |
| :------------: | :------------: | :------------: |
| put    | /api/v1/categories/{id} | Editar uma categoria  |
| delete | /api/v1/categories/{id} | Deletar uma categoria |

###### Obs: Apenas o usuários admin pode excluir ou deletar uma categoria.
### [Confira os End Points clicando aqui](https://laraproductapi.docs.apiary.io/#reference/0/rotas-publicas/listar-todos-os-produtos)

### OBS
Para receber e-mail quando a quantidade mínima de um determinado produto for atingido é necessário que você configure o serviço de e-mail no .env e rode o seguinte comando abaixo:
```sh
$ php artisan queue:work
```
## License

[MIT license](https://opensource.org/licenses/MIT).
