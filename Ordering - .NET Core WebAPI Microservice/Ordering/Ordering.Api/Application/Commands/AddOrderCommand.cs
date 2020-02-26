using MediatR;
using System;
using System.ComponentModel.DataAnnotations;
using System.Runtime.Serialization;

namespace Ordering.Api.Application.Commands
{
    [DataContract]
    public class AddOrderCommand : IRequest<Guid>
    {
        [Required]
        [DataMember(Name = "productId")]
        public Guid ProductId { get; }

        [Required]
        [DataMember(Name = "orderDate")]
        public DateTime OrderDate { get; }

        [Required]
        [DataMember(Name = "description")]
        public string Description { get; }

        public AddOrderCommand(Guid productId, DateTime orderDate, string description)
        {
            ProductId = productId;
            OrderDate = orderDate;
            Description = description;
        }
    }
}

