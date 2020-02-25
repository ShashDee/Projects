using FluentValidation;
using Ordering.Api.Application.Commands;
using System;

namespace Ordering.Api.Application.Validations
{
    public class UpdateProductCommandValidator : AbstractValidator<UpdateProductCommand>
    {
        public UpdateProductCommandValidator()
        {
            RuleFor(command => command.Id).NotEmpty().WithMessage("Product Id is required.");
            RuleFor(command => command.Name).NotEmpty().WithMessage("Product Name is required.");
            RuleFor(command => command.Description).NotEmpty().WithMessage("Product Description is required.");
            RuleFor(command => command.Price).NotEmpty().WithMessage("Product Price is required.").ScalePrecision(2, 6);
        }
    }
}
