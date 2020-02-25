using System;
using System.Collections.Generic;
using Dapper;
using System.Data.SqlClient;
using System.Threading.Tasks;
using Ordering.Api.Application.ViewModels;
using System.Reflection;
using System.Linq;
using Microsoft.Data.Sqlite;

namespace Ordering.Api.Application.Queries
{
    public class OrderQueries : IOrderQueries
    {
        private readonly string _connectionString;

        public OrderQueries(string constr)
        {
            _connectionString = !string.IsNullOrWhiteSpace(constr) ? constr : throw new ArgumentNullException(nameof(constr));
        }
        
        public async Task<IEnumerable<ViewModels.Order>> GetOrdersAsync()
        {
            using (var connection = new SqliteConnection(_connectionString))
            {
                connection.Open();

                var result = await connection.QueryAsync<dynamic>(
                    @"SELECT Orders.Id as Id, Orders.ProductId as ProductId, Products.Name as ProductName, Products.Description as ProductDescription, Products.Price as ProductPrice, Orders.Description as Description, Orders.OrderDate as OrderDate
                    FROM Orders
                    LEFT JOIN Products on Products.Id = Orders.ProductId"
                );

                if (result.AsList().Count > 0)
                    return MapOrders(result);

                return null;
            }
        }

        public async Task<ViewModels.Order> GetOrderByIdAsync(Guid id)
        {
            using (var connection = new SqliteConnection(_connectionString))
            {
                connection.Open();

                var result = await connection.QueryAsync<dynamic>(
                    @"SELECT Orders.Id as Id, Orders.ProductId as ProductId, Products.Name as ProductName, Products.Description as ProductDescription, Products.Price as ProductPrice, Orders.Description as Description, Orders.OrderDate as OrderDate
                    FROM Orders
                    LEFT JOIN Products on Products.Id = Orders.ProductId
                    WHERE Orders.Id = @id",
                    param: new { id }
                    );

                if (result.AsList().Count == 0)
                    throw new KeyNotFoundException();

                return MapOrder(result.FirstOrDefault());
            }
        }

        public async Task<IEnumerable<ViewModels.Order>> GetOrdesByProductIdAsync(Guid productId)
        {
            using (var connection = new SqliteConnection(_connectionString))
            {
                connection.Open();

                var result = await connection.QueryAsync<dynamic>(
                    @"SELECT Orders.Id as Id, Orders.ProductId as ProductId, Products.Name as ProductName, Products.Description as ProductDescription, Products.Price as ProductPrice, Orders.Description as Description, Orders.OrderDate as OrderDate
                    FROM Orders
                    LEFT JOIN Products on Products.Id = Orders.ProductId
                    WHERE Orders.ProductId = @productId",
                    param: new {productId}
                );

                if (result.AsList().Count > 0)
                    return MapOrders(result);

                return null;
            }
        }

        private List<ViewModels.Order> MapOrders(IEnumerable<dynamic> results)
        {
            var orders = new List<ViewModels.Order>();

            foreach (var result in results)
            {
                orders.Add(MapOrder(result));
            }

            return orders;
        }

        private ViewModels.Order MapOrder(dynamic result)
        {
            var order = new ViewModels.Order
            {
                Id = new Guid(result.Id),
                OrderProduct = new Product
                {
                    Id = new Guid(result.ProductId),
                    Name = result.ProductName,
                    Description = result.ProductDescription,
                    Price = (decimal)result.ProductPrice

                },
                OrderDate = DateTime.Parse(result.OrderDate),
                Description = result.Description
            };

            return order;
        }
    }
}
