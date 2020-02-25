using MediatR;
using System;
using System.ComponentModel.DataAnnotations;
using System.Runtime.Serialization;

namespace Ordering.Api.Application.Commands
{
    [DataContract]
    public class UpdateProductCommand : IRequest<bool>
    {
        [Required]
        [DataMember(Name = "id")]
        public Guid Id { get; }

        [Required]
        [DataMember(Name = "name")]
        public string Name { get; }

        [Required]
        [DataMember(Name = "description")]
        public string Description { get; }

        [Required]
        [DataMember(Name = "price")]
        public decimal Price { get; }


        public UpdateProductCommand(Guid id, string name, string description, decimal price)
        {
            Id = id;
            Name = name;
            Description = description;
            Price = price;
        }
    }
}

