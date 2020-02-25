using FluentValidation;
using Ordering.Api.Application.Commands;
using System;

namespace Ordering.Api.Application.Validations
{
    public class DeleteProductCommandValidator : AbstractValidator<DeleteProductCommand>
    {
        public DeleteProductCommandValidator()
        {
            RuleFor(command => command.Id).NotEmpty().WithMessage("Product Id is required.");
        }
    }
}
