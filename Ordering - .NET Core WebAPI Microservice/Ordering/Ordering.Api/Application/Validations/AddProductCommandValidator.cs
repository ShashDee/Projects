using FluentValidation;
using Ordering.Api.Application.Commands;
using System;

namespace Ordering.Api.Application.Validations
{
    public class AddProductCommandValidator : AbstractValidator<AddProductCommand>
    {
        public AddProductCommandValidator()
        {
            RuleFor(command => command.Name).NotEmpty().WithMessage("Product Name is required.");
            RuleFor(command => command.Description).NotEmpty().WithMessage("Product Description is required.");
            RuleFor(command => command.Price).NotEmpty().WithMessage("Product Price is required.").ScalePrecision(2, 6);
        }
    }
}
