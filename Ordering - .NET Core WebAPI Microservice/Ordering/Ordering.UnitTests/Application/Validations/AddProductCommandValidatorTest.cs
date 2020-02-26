using FluentValidation.TestHelper;
using Ordering.Api.Application.Commands;
using Ordering.Api.Application.Validations;
using Xunit;

namespace Ordering.UnitTests.Application.Validations
{
    public class AddProductCommandValidatorTest
    {
        private AddProductCommandValidator validator;

        public AddProductCommandValidatorTest()
        {
            validator = new AddProductCommandValidator();
        }

        [Fact]
        public void Name_not_empty_success()
        {
            var product = new AddProductCommand("Product Name", string.Empty, decimal.Zero);
            validator.ShouldNotHaveValidationErrorFor(p => p.Name, product);

        }

        [Fact]
        public void Name_is_empty_fail()
        {
            var product = new AddProductCommand("", string.Empty, decimal.Zero);
            validator.ShouldHaveValidationErrorFor(p => p.Name, product);

        }

        [Fact]
        public void Description_not_empty_success()
        {
            var product = new AddProductCommand(string.Empty, "Product Description", decimal.Zero);
            validator.ShouldNotHaveValidationErrorFor(p => p.Description, product);

        }

        [Fact]
        public void Description_is_empty_fail()
        {
            var product = new AddProductCommand(string.Empty, "", decimal.Zero);
            validator.ShouldHaveValidationErrorFor(p => p.Description, product);

        }

        [Fact]
        public void Price_not_empty_success()
        {
            var product = new AddProductCommand(string.Empty, string.Empty, (decimal)10.99);
            validator.ShouldNotHaveValidationErrorFor(p => p.Price, product);

        }

        [Fact]
        public void Price_is_empty_fail()
        {
            var product = new AddProductCommand(string.Empty, string.Empty, decimal.Zero);
            validator.ShouldHaveValidationErrorFor(p => p.Price, product);

        }

        [Fact]
        public void Price_is_not_in_precision_too_many_decimals_fail()
        {
            var product = new AddProductCommand(string.Empty, string.Empty, (decimal)121.19834);
            validator.ShouldHaveValidationErrorFor(p => p.Price, product);

        }

        [Fact]
        public void Price_is_not_in_precision_too_long_fail()
        {
            var product = new AddProductCommand(string.Empty, string.Empty, (decimal)12500.99);
            validator.ShouldHaveValidationErrorFor(p => p.Price, product);

        }
    }
}
