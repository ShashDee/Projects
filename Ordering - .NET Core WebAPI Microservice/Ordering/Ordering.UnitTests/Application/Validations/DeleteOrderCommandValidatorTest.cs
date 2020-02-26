using FluentValidation.TestHelper;
using Ordering.Api.Application.Commands;
using Ordering.Api.Application.Validations;
using System;
using Xunit;

namespace Ordering.UnitTests.Application.Validations
{
    public class DeleteOrderCommandValidatorTest
    {
        private DeleteOrderCommandValidator validator;

        public DeleteOrderCommandValidatorTest()
        {
            validator = new DeleteOrderCommandValidator();
        }

        [Fact]
        public void Id_not_empty_success()
        {
            var order = new DeleteOrderCommand(Guid.NewGuid());
            validator.ShouldNotHaveValidationErrorFor(p => p.Id, order);

        }

        [Fact]
        public void Id_empty_fail()
        {
            var order = new DeleteOrderCommand(Guid.Empty);
            validator.ShouldHaveValidationErrorFor(p => p.Id, order);

        }
    }
}
