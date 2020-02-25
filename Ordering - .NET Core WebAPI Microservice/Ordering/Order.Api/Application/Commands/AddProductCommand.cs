using MediatR;
using System;
using System.ComponentModel.DataAnnotations;
using System.Runtime.Serialization;

namespace Ordering.Api.Application.Commands
{
    [DataContract]
    public class AddProductCommand : IRequest<Guid>
    {
        [Required]
        [DataMember(Name = "name")]
        public string Name { get; }

        [Required]
        [DataMember(Name = "description")]
        public string Description { get; }

        [Required]
        [DataMember(Name = "price")]
        public decimal Price { get; }


        public AddProductCommand(string name, string description, decimal price)
        {
            Name = name;
            Description = description;
            Price = price;
        }
    }
}

