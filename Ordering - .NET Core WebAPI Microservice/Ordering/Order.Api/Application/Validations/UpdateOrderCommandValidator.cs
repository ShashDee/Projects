using FluentValidation;
using Ordering.Api.Application.Commands;
using System;

namespace Ordering.Api.Application.Validations
{
    public class UpdateOrderCommandValidator : AbstractValidator<UpdateOrderCommand>
    {
        public UpdateOrderCommandValidator()
        {
            RuleFor(command => command.Id).NotEmpty().WithMessage("Order Id is required.");
            RuleFor(command => command.ProductId).NotEmpty().WithMessage("Product Id is required.");
            RuleFor(command => command.OrderDate).NotEmpty().WithMessage("Order Date is required.");
            RuleFor(command => command.Description).NotEmpty().WithMessage("Order Description is required.");
        }
    }
}
