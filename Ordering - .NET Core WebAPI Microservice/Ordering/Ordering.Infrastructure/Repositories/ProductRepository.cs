using MedicalHistory.Infrastructure.Repositories;
using Ordering.Domain.Models.ProductAggregate;
using System;
using System.Collections.Generic;
using System.Text;

namespace Ordering.Infrastructure.Repositories
{
    public class ProductRepository : BaseEntityRepository<Product>
    {
        public ProductRepository(OrderContext context)
         : base(context, context.Products)
        {
        }
    }
}
