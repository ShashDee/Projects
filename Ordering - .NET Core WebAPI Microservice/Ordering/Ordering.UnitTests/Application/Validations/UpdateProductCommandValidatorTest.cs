using FluentValidation.TestHelper;
using Ordering.Api.Application.Commands;
using Ordering.Api.Application.Validations;
using Xunit;
using System;

namespace Ordering.UnitTests.Application.Validations
{
    public class UpdateProductCommandValidatorTest
    {
        private UpdateProductCommandValidator validator;

        public UpdateProductCommandValidatorTest()
        {
            validator = new UpdateProductCommandValidator();
        }


        [Fact]
        public void Id_not_empty_success()
        {
            var product = new UpdateProductCommand(Guid.NewGuid(), string.Empty, string.Empty, decimal.Zero);
            validator.ShouldNotHaveValidationErrorFor(p => p.Id, product);

        }

        [Fact]
        public void Id_is_empty_fail()
        {
            var product = new UpdateProductCommand(Guid.Empty, string.Empty, string.Empty, decimal.Zero);
            validator.ShouldHaveValidationErrorFor(p => p.Id, product);

        }

        [Fact]
        public void Name_not_empty_success()
        {
            var product = new UpdateProductCommand(Guid.Empty, "Product Name", string.Empty, decimal.Zero);
            validator.ShouldNotHaveValidationErrorFor(p => p.Name, product);

        }

        [Fact]
        public void Name_is_empty_fail()
        {
            var product = new UpdateProductCommand(Guid.Empty, "", string.Empty, decimal.Zero);
            validator.ShouldHaveValidationErrorFor(p => p.Name, product);

        }

        [Fact]
        public void Description_not_empty_success()
        {
            var product = new UpdateProductCommand(Guid.Empty, string.Empty, "Product Description", decimal.Zero);
            validator.ShouldNotHaveValidationErrorFor(p => p.Description, product);

        }

        [Fact]
        public void Description_is_empty_fail()
        {
            var product = new UpdateProductCommand(Guid.Empty, string.Empty, "", decimal.Zero);
            validator.ShouldHaveValidationErrorFor(p => p.Description, product);

        }

        [Fact]
        public void Price_not_empty_success()
        {
            var product = new UpdateProductCommand(Guid.Empty, string.Empty, string.Empty, (decimal)10.99);
            validator.ShouldNotHaveValidationErrorFor(p => p.Price, product);

        }

        [Fact]
        public void Price_is_empty_fail()
        {
            var product = new UpdateProductCommand(Guid.Empty, string.Empty, string.Empty, decimal.Zero);
            validator.ShouldHaveValidationErrorFor(p => p.Price, product);

        }

        [Fact]
        public void Price_is_not_in_precision_too_many_decimals_fail()
        {
            var product = new UpdateProductCommand(Guid.Empty, string.Empty, string.Empty, (decimal)150.999);
            validator.ShouldHaveValidationErrorFor(p => p.Price, product);

        }

        [Fact]
        public void Price_is_not_in_precision_too_long_fail()
        {
            var product = new UpdateProductCommand(Guid.Empty, string.Empty, string.Empty, (decimal)56000.99);
            validator.ShouldHaveValidationErrorFor(p => p.Price, product);

        }
    }
}
