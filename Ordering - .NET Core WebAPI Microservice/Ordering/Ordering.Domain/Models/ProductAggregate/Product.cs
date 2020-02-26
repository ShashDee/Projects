using System;
using System.Collections.Generic;
using System.ComponentModel.DataAnnotations;
using System.Text;

namespace Ordering.Domain.Models.ProductAggregate
{
    public class Product
    {
        [Key]
        public Guid Id { get; private set; }

        public string Name { get; private set; }

        public string Description { get; private set; }

        public decimal Price { get; private set; }

        protected Product()
        {
        }

        public Product(string name, string description, decimal price)
        {
            Id = Guid.NewGuid();
            Name = name;
            Description = description;
            Price = price;
        }

        public Product Update(string name, string description, decimal price)
        {
            Name = name;
            Description = description;
            Price = price;

            return this;
        }
    }
}
