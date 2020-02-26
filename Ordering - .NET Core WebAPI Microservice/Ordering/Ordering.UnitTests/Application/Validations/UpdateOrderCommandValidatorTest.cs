using FluentValidation.TestHelper;
using Ordering.Api.Application.Commands;
using Ordering.Api.Application.Validations;
using System;
using Xunit;

namespace Ordering.UnitTests.Application.Validations
{
    public class UpdateOrderCommandValidatorTest
    {
        private UpdateOrderCommandValidator validator;

        public UpdateOrderCommandValidatorTest()
        {
            validator = new UpdateOrderCommandValidator();
        }

        [Fact]
        public void Id_not_empty_success()
        {
            var order = new UpdateOrderCommand(Guid.NewGuid(), Guid.Empty, new DateTime(), string.Empty);
            validator.ShouldNotHaveValidationErrorFor(p => p.Id, order);

        }

        [Fact]
        public void Id_empty_fail()
        {
            var order = new UpdateOrderCommand(Guid.Empty, Guid.Empty, new DateTime(), string.Empty);
            validator.ShouldHaveValidationErrorFor(p => p.Id, order);

        }
        
        [Fact]
        public void Product_id_not_empty_success()
        {
            var order = new UpdateOrderCommand(Guid.Empty, Guid.NewGuid(), new DateTime(), string.Empty);
            validator.ShouldNotHaveValidationErrorFor(p => p.ProductId, order);

        }

        [Fact]
        public void Product_id_empty_fail()
        {
            var order = new UpdateOrderCommand(Guid.Empty, Guid.Empty, new DateTime(), string.Empty);
            validator.ShouldHaveValidationErrorFor(p => p.ProductId, order);

        }

        [Fact]
        public void Order_date_not_empty_success()
        {
            var order = new UpdateOrderCommand(Guid.Empty, Guid.Empty, DateTime.Now, string.Empty);
            validator.ShouldNotHaveValidationErrorFor(p => p.OrderDate, order);

        }

        [Fact]
        public void Order_date_empty_fail()
        {
            var order = new UpdateOrderCommand(Guid.Empty, Guid.Empty, new DateTime(), string.Empty);
            validator.ShouldHaveValidationErrorFor(p => p.OrderDate, order);

        }

        [Fact]
        public void Description_not_empty_success()
        {
            var order = new UpdateOrderCommand(Guid.Empty, Guid.Empty, new DateTime(), "Description");
            validator.ShouldNotHaveValidationErrorFor(p => p.Description, order);

        }

        [Fact]
        public void Description_empty_fail()
        {
            var order = new UpdateOrderCommand(Guid.Empty, Guid.Empty, new DateTime(), string.Empty);
            validator.ShouldHaveValidationErrorFor(p => p.Description, order);

        }
    }
}
