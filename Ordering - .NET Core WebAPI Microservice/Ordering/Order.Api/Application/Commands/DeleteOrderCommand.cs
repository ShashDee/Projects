using MediatR;
using System;
using System.ComponentModel.DataAnnotations;
using System.Runtime.Serialization;

namespace Ordering.Api.Application.Commands
{
    [DataContract]
    public class DeleteOrderCommand : IRequest<bool>
    {
        [Required]
        [DataMember(Name = "id")]
        public Guid Id { get; }


        public DeleteOrderCommand(Guid id)
        {
            Id = id;
        }
    }
}

