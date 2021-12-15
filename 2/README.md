## Test description

For inventory management, goods are stored in the following class:

```
class Article
{
    string $name;
    int $group;
    float $price;
}
```

Attributes:
1. The name attribute specifies the description of the product.
2. The group attribute indicates a group of products.
3. The price attribute indicates the price.

A class must be designed that takes an array or collection of articles as input parameters. The method should then return a new array or a new collection that sums all the articles with the same group, adds the price, and sums the comma-separated names with the new name. The name must not appear twice in the new name, separated by commas.

The exception is group 0 products, they cannot be combined.

Consider changing the combine rule. Business wants to combine articles according to a business rule that we know you don't yet know. Refactor your code to achieve this. As an example, we might want to group by name, an attribute that doesn't exist yet, or any condition that has nothing to do with articles at all.

## Usage

Start containers by command `docker-compose up --build -d`

Connect to the php container with the command `docker-compose exec php bash`, change the directory `cd public` and you can execute the command `php index.php`

The application contains a configuration file, parameters:

1. `grouper` - This parameter allows you to set which grouping class will be generated. `default` - generates object GrouperDefault
2. `sort` - This parameter allows you to set by which field the articles in the collection will be sorted. Allowed values: name, group, price.
3. `sort_type` - This parameter allows you to set by what type to sort in ascending or descending order. Allowed values: ASC, DESC.
