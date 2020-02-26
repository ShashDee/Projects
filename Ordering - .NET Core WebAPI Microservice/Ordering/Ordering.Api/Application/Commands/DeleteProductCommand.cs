using MediatR;
using System;
using System.ComponentModel.DataAnnotations;
using System.Runtime.Serialization;

namespace Ordering.Api.Application.Commands
{
    [DataContract]
    public class DeleteProductCommand : IRequest<bool>
    {
        [Required]
        [DataMember(Name = "id")]
        public Guid Id { get; }


        public DeleteProductCommand(Guid id)
        {
            Id = id;
        }
    }
}

