using FluentValidation;
using Ordering.Api.Application.Commands;
using System;

namespace Ordering.Api.Application.Validations
{
    public class AddOrderCommandValidator : AbstractValidator<AddOrderCommand>
    {
        public AddOrderCommandValidator()
        {
            RuleFor(command => command.ProductId).NotEmpty().WithMessage("Product Id is required.");
            RuleFor(command => command.OrderDate).NotEmpty().WithMessage("Order Date is required.");
            RuleFor(command => command.Description).NotEmpty().WithMessage("Order Description is required.");
        }
    }
}
