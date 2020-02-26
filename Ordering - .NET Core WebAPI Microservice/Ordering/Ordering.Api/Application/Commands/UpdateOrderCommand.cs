using MediatR;
using System;
using System.ComponentModel.DataAnnotations;
using System.Runtime.Serialization;

namespace Ordering.Api.Application.Commands
{
    [DataContract]
    public class UpdateOrderCommand : IRequest<bool>
    {
        [Required]
        [DataMember(Name = "id")]
        public Guid Id { get; }

        [Required]
        [DataMember(Name = "productId")]
        public Guid ProductId { get; }

        [Required]
        [DataMember(Name = "orderDate")]
        public DateTime OrderDate { get; }

        [Required]
        [DataMember(Name = "description")]
        public string Description { get; }

        public UpdateOrderCommand(Guid id, Guid productId, DateTime orderDate, string description)
        {
            Id = id;
            ProductId = productId;
            OrderDate = orderDate;
            Description = description;
        }
    }
}

