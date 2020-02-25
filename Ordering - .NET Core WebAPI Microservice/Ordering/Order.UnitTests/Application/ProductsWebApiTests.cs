using MediatR;
using Microsoft.AspNetCore.Mvc;
using Microsoft.Extensions.Logging;
using Moq;
using Ordering.Api.Application.Queries;
using Ordering.Api.Application.ViewModels;
using Ordering.Api.Controllers;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using Xunit;

namespace Ordering.UnitTests.Application
{
    public class ProductsWebApiTests
    {
        private readonly Mock<IMediator> _mediatorMock;
        private readonly Mock<IProductQueries> _productQueriesMock;
        private readonly Mock<ILogger<ProductController>> _loggerMock;

        public ProductsWebApiTests()
        {
            _mediatorMock = new Mock<IMediator>();
            _productQueriesMock = new Mock<IProductQueries>();
            _loggerMock = new Mock<ILogger<ProductController>>();
        }

        [Fact]
        public async Task Get_products_success()
        {
            //Arrange
            var fakeDynamicResult = Enumerable.Empty<Product>();

            _productQueriesMock.Setup(x => x.GetProductsAsync())
                .Returns(Task.FromResult(fakeDynamicResult));

            //Act
            var productController = new ProductController(_mediatorMock.Object, _productQueriesMock.Object, _loggerMock.Object);
            var actionResult = await productController.GetProductsAsync();

            //Assert
            Assert.Equal((actionResult.Result as OkObjectResult).StatusCode, (int)System.Net.HttpStatusCode.OK);
        }
    }
}
