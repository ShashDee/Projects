using MediatR;
using Microsoft.AspNetCore.Mvc;
using Microsoft.Extensions.Logging;
using Moq;
using Ordering.Api.Application.Commands;
using Ordering.Api.Application.Queries;
using Ordering.Api.Application.ViewModels;
using Ordering.Api.Controllers;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading;
using System.Threading.Tasks;
using Xunit;

namespace Ordering.UnitTests.Application
{
    public class ProductControllerTests
    {
        private readonly Mock<IMediator> _mediatorMock;
        private readonly Mock<IProductQueries> _productQueriesMock;
        private readonly Mock<ILogger<ProductController>> _loggerMock;

        public ProductControllerTests()
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
            Assert.Equal((int)System.Net.HttpStatusCode.OK, (actionResult.Result as OkObjectResult).StatusCode);
        }

        [Fact]
        public async Task Get_product_by_Id_success()
        {
            //Arrange
            Guid fakeProductId = new Guid();
            var fakeDynamicResult = new Product();
            _productQueriesMock.Setup(x => x.GetProductByIdAsync(It.IsAny<Guid>()))
                .Returns(Task.FromResult(fakeDynamicResult));

            //Act
            var productController = new ProductController(_mediatorMock.Object, _productQueriesMock.Object, _loggerMock.Object);
            var actionResult = await productController.GetProductByIdAsync(fakeProductId);

            //Assert
            Assert.Equal((int)System.Net.HttpStatusCode.OK, (actionResult.Result as OkObjectResult).StatusCode);
        }

        [Fact]
        public async Task Get_product_by_Id_fail()
        {
            //Arrange
            Guid fakeProductId = new Guid();
            var fakeDynamicResult = new KeyNotFoundException();
            _productQueriesMock.Setup(x => x.GetProductByIdAsync(It.IsAny<Guid>()))
                .Throws(new KeyNotFoundException());

            //Act
            var productController = new ProductController(_mediatorMock.Object, _productQueriesMock.Object, _loggerMock.Object);

            //Assert
            await Assert.ThrowsAsync<KeyNotFoundException>(() => productController.GetProductByIdAsync(fakeProductId));
        }

        [Fact]
        public async Task Get_product_by_Name_success()
        {

            //Arrange
            string fakeProductName = string.Empty;
            var fakeDynamicResult = Enumerable.Empty<Product>();

            _productQueriesMock.Setup(x => x.GetProductsByNameAsync(It.IsAny<String>()))
                .Returns(Task.FromResult(fakeDynamicResult));

            //Act
            var productController = new ProductController(_mediatorMock.Object, _productQueriesMock.Object, _loggerMock.Object);
            var actionResult = await productController.GetProductsByNameAsync(fakeProductName);

            //Assert
            Assert.Equal((int)System.Net.HttpStatusCode.OK, (actionResult.Result as OkObjectResult).StatusCode);
        }

        [Fact]
        public async Task Add_product_with_all_details_success()
        {
            //Arrange
            _mediatorMock.Setup(m => m.Send(It.IsAny<AddProductCommand>(), It.IsAny<CancellationToken>()))
                .ReturnsAsync(new Guid());

            //Act
            var productController = new ProductController(_mediatorMock.Object, _productQueriesMock.Object, _loggerMock.Object);
            var actionResult = await productController.AddProduct(new AddProductCommand("New Product", "Testing", (decimal)10.00));

            //Assert
            Assert.Equal(new Guid(), actionResult.Value);
        }

        [Fact]
        public async Task Update_product_with_all_details_success()
        {
            //Arrange
            _mediatorMock.Setup(m => m.Send(It.IsAny<UpdateProductCommand>(), It.IsAny<CancellationToken>()))
                .ReturnsAsync(true);

            //Act
            var productController = new ProductController(_mediatorMock.Object, _productQueriesMock.Object, _loggerMock.Object);
            var actionResult = await productController.UpdatedProduct(new UpdateProductCommand(new Guid(), "New Product", "Update Testing", (decimal)15.00));

            //Assert
            Assert.True(actionResult.Value);

        }

        [Fact]
        public async Task Update_product_non_existing_id_fail()
        {
            //Arrange
            _mediatorMock.Setup(m => m.Send(It.IsAny<UpdateProductCommand>(), It.IsAny<CancellationToken>()))
                .ThrowsAsync(new KeyNotFoundException());

            //Act
            var productController = new ProductController(_mediatorMock.Object, _productQueriesMock.Object, _loggerMock.Object);

            //Assert
            await Assert.ThrowsAsync<KeyNotFoundException>(() => productController.UpdatedProduct(new UpdateProductCommand(new Guid(), "New Product", "Update Testing", (decimal)15.00)));

        }

        [Fact]
        public async Task Delete_product_success()
        {
            //Arrange
            _mediatorMock.Setup(m => m.Send(It.IsAny<DeleteProductCommand>(), It.IsAny<CancellationToken>()))
                .ReturnsAsync(true);

            //Act
            var productController = new ProductController(_mediatorMock.Object, _productQueriesMock.Object, _loggerMock.Object);
            var actionResult = await productController.DeleteProduct(new Guid());

            //Assert
            Assert.True(actionResult.Value);

        }

        [Fact]
        public async Task Delete_product_non_existing_id_fail()
        {
            //Arrange
            _mediatorMock.Setup(m => m.Send(It.IsAny<DeleteProductCommand>(), It.IsAny<CancellationToken>()))
                .ThrowsAsync(new KeyNotFoundException());

            //Act
            var productController = new ProductController(_mediatorMock.Object, _productQueriesMock.Object, _loggerMock.Object);

            //Assert
            await Assert.ThrowsAsync<KeyNotFoundException>(() => productController.DeleteProduct(new Guid()));

        }
    }
}
