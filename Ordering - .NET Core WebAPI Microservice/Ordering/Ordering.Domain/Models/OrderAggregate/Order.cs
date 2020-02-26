using System;
using System.Collections.Generic;
using System.ComponentModel.DataAnnotations;
using System.Text;
using Ordering.Domain.Models.ProductAggregate;

namespace Ordering.Domain.Models.OrderAggregate
{
    public class Order
    {
        [Key]
        public Guid Id { get; private set; }
        public Product OrderProduct { get; private set; }
        public virtual Guid ProductId { get; private set; }
        public DateTime OrderDate { get; private set; }
        public string Description { get; private set; }

        protected Order()
        {
        }

        public Order(Guid productId, DateTime orderDate, string description)
        {
            Id = Guid.NewGuid();
            ProductId = productId;
            OrderDate = orderDate;
            Description = description;
        }

        public Order Update(Guid productId, DateTime orderDate, string description)
        {
            ProductId = productId;
            OrderDate = orderDate;
            Description = description;

            return this;
        }

        public void Delete(Order order)
        {
            this.Delete(order);
        }
    }
}
