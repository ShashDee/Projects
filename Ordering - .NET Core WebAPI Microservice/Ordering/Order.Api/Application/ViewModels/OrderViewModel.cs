using System;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;

namespace Ordering.Api.Application.ViewModels
{
    public class Order
    {
        public Guid Id { get; set; }
        public Product OrderProduct { get; set; }
        public DateTime OrderDate { get; set; }
        public string Description { get; set; }
    }
}
