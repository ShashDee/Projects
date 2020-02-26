using FluentValidation.TestHelper;
using Ordering.Api.Application.Commands;
using Ordering.Api.Application.Validations;
using Xunit;
using System;

namespace Ordering.UnitTests.Application.Validations
{
    public class DeleteProductCommandValidatorTest
    {
        private DeleteProductCommandValidator validator;

        public DeleteProductCommandValidatorTest()
        {
            validator = new DeleteProductCommandValidator();
        }


        [Fact]
        public void Id_not_empty_success()
        {
            var product = new DeleteProductCommand(Guid.NewGuid());
            validator.ShouldNotHaveValidationErrorFor(p => p.Id, product);
        }

        [Fact]
        public void Id_is_empty_fail()
        {
            var product = new DeleteProductCommand(Guid.Empty);
            validator.ShouldHaveValidationErrorFor(p => p.Id, product);
        }
    }
}
