using System;
using System.Collections.Generic;
using Dapper;
using System.Data.SqlClient;
using System.Threading.Tasks;
using Ordering.Api.Application.ViewModels;
using System.Reflection;
using System.Linq;
using Microsoft.Data.Sqlite;
using Ordering.Domain.Models;

namespace Ordering.Api.Application.Queries
{
    public class ProductQueries : IProductQueries
    {
        private readonly string _connectionString;

        public ProductQueries(string constr)
        {
            _connectionString = !string.IsNullOrWhiteSpace(constr) ? constr : throw new ArgumentNullException(nameof(constr));
        }

        public async Task<IEnumerable<Product>> GetProductsAsync()
        {
            using (var connection = new SqliteConnection(_connectionString))
            {
                connection.Open();

                var result = await connection.QueryAsync<dynamic>(
                    @"SELECT Id, Name, Description, Price
                    FROM Products"
                );

                if (result.AsList().Count > 0)
                    return MapProducts(result);

                return Enumerable.Empty<Product>();
            }
        }

        public async Task<Product> GetProductByIdAsync(Guid id)
        {
            using (var connection = new SqliteConnection(_connectionString))
            {
                connection.Open();

                var result = await connection.QueryAsync<dynamic>(
                    @"SELECT Id, Name, Description, Price
                    FROM Products
                    WHERE Id = @id",
                    param: new { id }
                    );

                if (result.AsList().Count == 0)
                    throw new KeyNotFoundException(); 

                return MapProduct(result.FirstOrDefault());
            }
        }

        public async Task<IEnumerable<Product>> GetProductsByNameAsync(string name)
        {
            using (var connection = new SqliteConnection(_connectionString))
            {
                connection.Open();

                var result = await connection.QueryAsync<dynamic>(
                    @"SELECT Id, Name, Description, Price
                    FROM Products
                    WHERE lower(Name) LIKE @productName",
                    param: new { productName = '%'+name.ToLower()+'%' }
                    );

                if (result.AsList().Count > 0)
                    return MapProducts(result);

                return Enumerable.Empty<Product>();
            }
        }

        private List<Product> MapProducts(IEnumerable<dynamic> results)
        {
            var products = new List<Product>();

            foreach(var result in results)
            {
                products.Add(MapProduct(result));
            }

            return products;
        }

        private Product MapProduct(dynamic result)
        {
            var product = new Product
            {
                Id = new Guid(result.Id),
                Name = result.Name,
                Description = result.Description,
                Price = (decimal) result.Price
            };

            return product;
        }
    }
}
